<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServiceCollection;
use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $services = Service::when(
            $request->search,
            fn($builder, $search) =>
            $builder->where('service', 'LIKE', "%{$search}%")
        )->when(
                $request->category,
                fn($builder, $category) =>
                $builder->where(
                    'category_service_id',
                    $category
                )
            )->paginate(20);

        return new ServiceCollection($services);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'service' => ['required', 'max:100'],
            'image' => ['required', 'image', 'max:2048'],
            'description' => ['required'],
            'price' => ['required', 'numeric', 'min:0'],
            'category_service_id' => ['required', 'exists:category_services,id'],
        ]);

        $file = $request->file('image');
        $nameImage = Str::uuid() . '.' . $file->extension();

        $image = Image::read($file);
        $image->cover(500, 500);

        if (!File::exists(Storage::path('services'))) {
            File::makeDirectory(Storage::path('services'));
        }

        $image->save(Storage::path("services/{$nameImage}"));

        $data['image'] = $nameImage;

        Service::create($data);

        return response()->json(['message' => 'El servicio ha sido creado.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return new ServiceCollection([$service->load('category')]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'service' => ['required', 'max:100'],
            'image' => ['image', 'max:2048'],
            'description' => ['required'],
            'price' => ['required', 'numeric', 'min:0'],
            'category_service_id' => ['required', 'exists:category_services,id'],
        ]);

        $file = $request->file('image');

        if ($file) {
            $nameImage = Str::uuid() . '.' . $file->extension();

            $image = Image::read($file);
            $image->cover(500, 500);

            if (!File::exists(Storage::path('services'))) {
                File::makeDirectory(Storage::path('services'));
            }

            $image->save(Storage::path("services/{$nameImage}"));
            Storage::delete("services/{$service->image}");
            $service->image = $nameImage;
        }

        $service->service = $data['service'];
        $service->description = $data['description'];
        $service->price = $data['price'];
        $service->category_service_id = $data['category_service_id'];
        $service->save();

        return response()->json(['message' => 'El servicio ha sido actualizado.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        Storage::delete("services/{$service->image}");
        $service->delete();
        return response()->json(['message' => 'El servicio ha sido eliminado.']);
    }
}

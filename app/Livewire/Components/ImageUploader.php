<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use App\Models\Image;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;

final class ImageUploader extends Component
{
    use WithFileUploads;

    public ?Model $model = null;

    /** @var array<int, TemporaryUploadedFile> */
    public array $images = [];

    public string $storagePath = '';

    /**
     * @var array<int, array{
     *     id: int,
     *     path: string,
     *     url: string,
     *     is_cover: bool
     * }>
     */
    public array $existingImages = [];

    public function mount(?Model $model = null, string $storagePath = 'images'): void
    {
        $this->model = $model;
        $this->storagePath = $storagePath;

        if ($this->model && method_exists($this->model, 'images')) {
            /** @var MorphMany<Image, Model> $relation */
            $relation = $this->model->images();

            /**
             * @var array<int, array{
             *     id: int,
             *     path: string,
             *     url: string,
             *     is_cover: bool
             * }> $res
             */
            $res = $relation
                ->orderBy('is_cover', 'desc')
                ->get()
                ->map(fn (Image $image): array => [
                    'id' => $image->id,
                    'path' => $image->path,
                    'url' => Storage::temporaryUrl($image->path, now()->addMinute()),
                    'is_cover' => $image->is_cover,
                ])->toArray();

            $this->existingImages = $res;
        }
    }

    public function removePendingImage(int $index): void
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
    }

    public function saveImages(): void
    {
        if (! $this->model || ! method_exists($this->model, 'images') || $this->images === []) {
            return;
        }

        $this->validate([
            'images.*' => 'image|max:2048',
        ]);

        /** @var MorphMany<Image, Model> $relation */
        $relation = $this->model->images();

        $hasNoCover = $relation->where('is_cover', true)->doesntExist();

        foreach ($this->images as $index => $image) {
            $path = $image->store($this->storagePath);

            $relation->create([
                'path' => $path,
                'is_cover' => $hasNoCover && $index === 0,
            ]);

            $this->images = [];
            $this->mount($this->model, $this->storagePath);
            Toaster::success('Imagens armazenadas com sucesso');
        }
    }

    public function setCover(int $imageId): void
    {
        if (! $this->model || ! method_exists($this->model, 'images')) {
            return;
        }

        /** @var MorphMany<Image, Model> $relation */
        $relation = $this->model->images();

        $relation->update(['is_cover' => false]);
        $relation->where('id', $imageId)->update(['is_cover' => true]);

        $this->mount($this->model, $this->storagePath);
        Toaster::success('Capa Atualizada com sucesso');
    }

    public function removeExistingImage(Image $image): void
    {
        if (! $this->model || ! method_exists($this->model, 'images')) {
            return;
        }

        Storage::delete($image->path);
        $image->delete();

        $this->mount($this->model, $this->storagePath);
        Toaster::success('Imagem removida com sucesso');
    }

    public function render(): ViewFactory|ViewContract
    {
        return view('livewire.components.image-uploader');
    }
}

<?php
namespace App\Orchid\Components;

use Orchid\Screen\Field;

class ImagePreview extends Field
{
    protected $view = 'components.image-preview';

    public function __construct()
    {
        $this->addBeforeRender(function () {
            $this->set('imageUrl', '');  // Inicialmente vacío
            $this->set('title', '');  // Inicialmente vacío
            $this->set('containerId', '');  // Inicialmente vacío
            $this->set('imageId', '');  // Inicialmente vacío
        });
    }

    public function setImageUrl($url)
    {
        $this->set('imageUrl', $url);
        return $this;
    }

    public function title($title)
    {
        $this->set('title', $title);
        return $this;
    }

    public function containerId($id)
    {
        $this->set('containerId', $id);
        return $this;
    }

    public function imageId($id)
    {
        $this->set('imageId', $id);
        return $this;
    }

    public function render()
    {
        return view($this->view, [
            'imageUrl' => $this->get('imageUrl'),
            'title' => $this->get('title'),
            'containerId' => $this->get('containerId'),
            'imageId' => $this->get('imageId'),
        ])->render();
    }
}

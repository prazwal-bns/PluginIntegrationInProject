<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Przwl\MultiSourceFileUpload\Components\MultiSourceFileUpload;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Textarea::make('content')
                    ->required()
                    ->maxLength(1000),
                ...(MultiSourceFileUpload::make('image', 'image_url')
                    ->required()
                    ->image())
                    ->getSchema(),
            ]);
    }
}

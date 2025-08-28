<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),

                // Subtotal field (manual or from items later)
                TextInput::make('subtotal')
                    ->required()
                    ->numeric()
                    ->prefix('KES ')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function($state, callable $set, callable $get) {
                        // Update grand total when subtotal changes
                        $set('grand_total', ($state ?? 0) + ($get('shipping_amount') ?? 0));
                    }),

                TextInput::make('shipping_amount')
                    ->numeric()
                    ->prefix('KES ')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $set('grand_total', ($get('subtotal') ?? 0) + ($state ?? 0));
                    }),

                // Auto-calculated grand total
                TextInput::make('grand_total')
                    ->numeric()
                    ->prefix('KES ')
                    ->disabled()       // user cannot edit
                    ->dehydrated(),    // still saved to DB
                    

                TextInput::make('payment_method'),

                TextInput::make('payment_status'),

                TextInput::make('status')
                    ->required()
                    ->default('new'),

                TextInput::make('currency')
                    ->default('KES'),

                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}

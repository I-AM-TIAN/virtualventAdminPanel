<x-filament::page>
    {{-- Información general de la orden --}}
    <x-filament::section>
        <x-slot name="heading">Detalle de la orden</x-slot>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <strong>UUID:</strong> {{ $record->uuid }}
            </div>
            <div>
                <strong>Total:</strong> ${{ number_format($record->total, 0, ',', '.') }}
            </div>
            <div>
                <strong>Productos:</strong> {{ $record->num_items }}
            </div>
            <div>
                <strong>Estado del pago:</strong>
                <span class="{{ $record->pagado ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold' }}">
                    {{ $record->pagado ? 'Pagado' : 'Sin pagar' }}
                </span>
            </div>
            <div>
                <strong>Fecha de pago:</strong> {{ $record->fecha_pago?->format('d/m/Y') }}
            </div>
        </div>
    </x-filament::section>

    {{-- Productos pedidos --}}
    <x-filament::section>
        <x-slot name="heading">Productos pedidos</x-slot>

        <x-filament::card>
            <table class="w-full table-auto text-sm border">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="px-4 py-2 border">Nombre</th>
                        <th class="px-4 py-2 border">Cantidad</th>
                        <th class="px-4 py-2 border">Precio Unitario</th>
                        <th class="px-4 py-2 border">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($record->item_orden as $item)
                        <tr class="border-b">
                            <td class="px-4 py-2 border">{{ $item->producto->nombre }}</td>
                            <td class="px-4 py-2 border">{{ $item->cantidad }}</td>
                            <td class="px-4 py-2 border">
                                ${{ number_format($item->producto->precio, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-2 border">
                                ${{ number_format($item->producto->precio * $item->cantidad, 0, ',', '.') }}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </x-filament::card>
    </x-filament::section>
</x-filament::page>

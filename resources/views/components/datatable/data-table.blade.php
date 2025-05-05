<div class="overflow-x-auto">
    <table id="{{ $id }}" class="data-table min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                @foreach ($columns as $column)
                    <th class="{{ $column['width'] ?? '' }} {{ $column['className'] ?? '' }}">
                        {{ $column['title'] }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @for ($i = 0; $i < 5; $i++)
                <tr class="animate-pulse">
                    @foreach ($columns as $column)
                        <td class="{{ $column['className'] ?? '' }}">
                            <div class="skeleton"></div>
                        </td>
                    @endforeach
                </tr>
            @endfor
        </tbody>
    </table>
</div>

<script>
    window.dataTableConfig = window.dataTableConfig || {};
    window.dataTableConfig['{{ $id }}'] = {
        ajax: '{{ $ajax }}',
        columns: @json($columns)
    };
</script>

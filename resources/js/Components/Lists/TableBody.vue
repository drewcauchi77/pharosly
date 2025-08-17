<script setup>
const props = defineProps({
    items: {
        type: Array,
        default: () => [],
    },
    columns: {
        type: Array,
        default: () => [],
    },
    rowKey: {
        type: [String, Function],
        default: 'id',
    },
});

function formatValue(value, item, column) {
    if (typeof column.formatter === 'function') return column.formatter(value, item);
    return value ?? '';
}
</script>

<template>
    <tbody v-if="items?.length">
        <tr
            v-for="(item, rowIndex) in items"
            :key="`row-${rowIndex}`"
        >
            <td
                v-for="(column, colIndex) in columns"
                :key="column.key ?? colIndex"
                :data-column-id="column.key"
                class="p-3 border-collapse border border-light-blue"
            >
                <slot
                    :name="`cell-${column.key}`"
                    :item="item"
                    :value="item?.[column.key]"
                    :row-index="rowIndex"
                    :col-index="colIndex"
                    :column="column"
                >
                    {{ formatValue(item?.[column.key], item, column) }}
                </slot>
            </td>
        </tr>
    </tbody>

    <tbody v-else>
        <tr>
            <td :colspan="Math.max(columns.length, 1)" class="p-3">
                <slot name="empty">No data.</slot>
            </td>
        </tr>
    </tbody>
</template>

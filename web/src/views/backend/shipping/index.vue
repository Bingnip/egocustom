<template>
    <div class="default-main ba-table-box">
        <el-alert class="ba-table-alert" v-if="baTable.table.remark" :title="baTable.table.remark" type="info" show-icon />

        <!-- 表格顶部菜单 -->
        <!-- 自定义按钮请使用插槽，甚至公共搜索也可以使用具名插槽渲染，参见文档 -->
        <TableHeader
            :buttons="['refresh', 'add', 'edit', 'delete', 'comSearch', 'quickSearch', 'columnDisplay']"
            :quick-search-placeholder="t('Quick search placeholder', { fields: t('shipping.quick Search Fields') })"
        ></TableHeader>

        <!-- 表格 -->
        <!-- 表格列有多种自定义渲染方式，比如自定义组件、具名插槽等，参见文档 -->
        <!-- 要使用 el-table 组件原有的属性，直接加在 Table 标签上即可 -->
        <Table ref="tableRef"></Table>

        <!-- 表单 -->
        <PopupForm />
    </div>
</template>

<script setup lang="ts">
import { onMounted, provide, ref } from 'vue'
import { useI18n } from 'vue-i18n'
import PopupForm from './popupForm.vue'
import { baTableApi } from '/@/api/common'
import { defaultOptButtons } from '/@/components/table'
import TableHeader from '/@/components/table/header/index.vue'
import Table from '/@/components/table/index.vue'
import baTableClass from '/@/utils/baTable'

defineOptions({
    name: 'shipping',
})

const { t } = useI18n()
const tableRef = ref()
const optButtons: OptButton[] = defaultOptButtons(['edit', 'delete'])

/**
 * baTable 内包含了表格的所有数据且数据具备响应性，然后通过 provide 注入给了后代组件
 */
const baTable = new baTableClass(
    new baTableApi('/admin/Shipping/'),
    {
        pk: 'ship_id',
        column: [
            { type: 'selection', align: 'center', operator: false },
            { label: t('shipping.ship_id'), prop: 'ship_id', align: 'center', width: 70, operator: 'RANGE', sortable: 'custom' },
            { label: t('shipping.ship_name'), prop: 'ship_name', align: 'center', operatorPlaceholder: t('Fuzzy query'), operator: 'LIKE', sortable: false },
            { label: t('shipping.ship_full_name'), prop: 'ship_full_name', align: 'center', operator: false, sortable: false },
            { label: t('shipping.ship_code'), prop: 'ship_code', align: 'center', operatorPlaceholder: t('Fuzzy query'), render: 'url', operator: 'LIKE', sortable: false },
            { label: t('shipping.ship_desc'), prop: 'ship_desc', align: 'center', operator: false, sortable: false },
            { label: t('shipping.ship_html_desc'), prop: 'ship_html_desc', align: 'center', operator: false, sortable: false },
            { label: t('shipping.ship_order'), prop: 'ship_order', align: 'center', operator: 'eq', sortable: false },
            { label: t('shipping.ship_status'), prop: 'ship_status', align: 'center', operator: 'eq', sortable: false },
            { label: t('shipping.deliver_string'), prop: 'deliver_string', align: 'center', operator: false, sortable: false },
            { label: t('shipping.deliver_min_days'), prop: 'deliver_min_days', align: 'center', operator: false, sortable: false },
            { label: t('shipping.deliver_max_days'), prop: 'deliver_max_days', align: 'center', operator: false, sortable: false },
            { label: t('shipping.tel_required'), prop: 'tel_required', align: 'center', operator: false, sortable: false },
            { label: t('shipping.base_fee'), prop: 'base_fee', align: 'center', operator: false, sortable: false },
            { label: t('shipping.free_amount'), prop: 'free_amount', align: 'center', operator: false, sortable: false },
            { label: t('shipping.accept_country'), prop: 'accept_country', align: 'center', operator: false, sortable: false },
            { label: t('shipping.deny_country'), prop: 'deny_country', align: 'center', operator: false, sortable: false },
            { label: t('Operate'), align: 'center', width: 100, render: 'buttons', buttons: optButtons, operator: false },
        ],
        dblClickNotEditColumn: [undefined],
    },
    {
        defaultItems: { ship_order: 0, ship_status: 0, deliver_min_days: 0, deliver_max_days: 0, tel_required: 0, base_fee: 0, free_amount: 0 },
    }
)

provide('baTable', baTable)

onMounted(() => {
    baTable.table.ref = tableRef.value
    baTable.mount()
    baTable.getIndex()?.then(() => {
        baTable.initSort()
        baTable.dragSort()
    })
})
</script>

<style scoped lang="scss"></style>

<template>
    <div class="default-main ba-table-box">
        <TableHeader :buttons="['refresh', 'add', 'edit', 'delete', 'comSearch', 'quickSearch', 'columnDisplay']" />

        <Table ref="tableRef">
            <template #iconColumn>
                <el-table-column prop="crc_icon" label="图标" width="70" align="center">
                    <template #default="scope">
                        <el-image :src="scope.row['crc_icon']" style="width: 20px; height: 20px" />
                    </template>
                </el-table-column>
                <el-table-column prop="crc_status" label="状态" width="70" align="center">
                    <template #default="scope">
                        <span v-if="scope.row['crc_status'] == 1" style="color: #67c23a">正常</span>
                        <span v-else style="color: #f56c6c">禁用</span>
                    </template>
                </el-table-column>
            </template>
        </Table>
        <PopupForm />
    </div>
</template>

<script setup lang="ts">
import { onMounted, ref, provide } from 'vue'
import baTableClass from '/@/utils/baTable'
import Table from '/@/components/table/index.vue'
import { getList } from '/@/api/backend/siteManage/currencyConfig'
import { defaultOptButtons } from '/@/components/table'
import { baTableApi } from '/@/api/common'
import { useI18n } from 'vue-i18n'

defineOptions({
    name: 'siteManage/currencyConfig',
})

let optBtn = defaultOptButtons([])
let newButton: OptButton[] = [
    {
        render: 'tipButton',
        name: 'editor',
        text: '',
        type: 'primary',
        icon: 'fa fa-pencil',
        class: 'table-row-edit',
        click: (row: TableRow) => {
            console.log(row)
        },
    },
    {
        render: 'confirmButton',
        name: 'remove',
        text: '',
        type: 'danger',
        icon: 'fa fa-trash',
        disabledTip: false,
        class: 'table-row-delete',
        popconfirm: { title: '确认删除吗？', confirmButtonText: '确定', cancelButtonText: '取消' },
        click: (row: TableRow, field: TableColum) => {},
    },
]
optBtn = newButton.concat(optBtn)
const { t } = useI18n()
const tableRef = ref()
const baTable = new baTableClass(new baTableApi('/admin/siteManage.CurrencyConfig/'), {
    column: [
        { type: 'selection', align: 'center', operator: false },
        { label: t('user.user.User name'), prop: 'crc_id', align: 'center', width: 70 },
        { label: t('Code'), prop: 'crc_code', align: 'center', width: 70 },
        { label: t('货币名称'), prop: 'crc_name', align: 'center', width: 130 },
        { label: t('符号'), prop: 'crc_sign', align: 'center', width: 70 },
        { label: t('汇率（与美元）'), prop: 'crc_rate', align: 'center', width: 130 },
        { label: t('兑换加收比率'), prop: 'crc_exchange_rate', align: 'center', width: 130 },
        { render: 'slot', slotName: 'iconColumn', width: 70 },
        { label: t('添加时间'), prop: 'crc_created_at', align: 'center', render: 'datetime', width: 130 },
        { label: t('更新时间'), prop: 'crc_updated_at', align: 'center', render: 'datetime', width: 130 },
        { label: t('备注'), prop: 'crc_memo', align: 'center', width: 130 },
        {
            label: t('Operate'),
            align: 'center',
            render: 'buttons',
            buttons: optBtn,
            operator: false,
        },
    ],
    dblClickNotEditColumn: [undefined],
})

onMounted(() => {
    baTable.table.ref = tableRef.value
    baTable.mount()
    baTable.getIndex()
})
provide('baTable', baTable)
</script>

<style scoped lang="scss"></style>

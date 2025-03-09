<template>
    <div class="default-main ba-table-box">
        <el-alert class="ba-table-alert" v-if="baTable.table.remark" :title="baTable.table.remark" type="info" show-icon />

        <!-- 表格顶部菜单 -->
        <!-- 自定义按钮请使用插槽，甚至公共搜索也可以使用具名插槽渲染，参见文档 -->
        <TableHeader :buttons="['refresh', 'add', 'edit', 'delete', 'comSearch', 'columnDisplay']"></TableHeader>

        <!-- 表格 -->
        <!-- 表格列有多种自定义渲染方式，比如自定义组件、具名插槽等，参见文档 -->
        <!-- 要使用 el-table 组件原有的属性，直接加在 Table 标签上即可 -->
        <Table ref="tableRef">
            <template #other>
                <el-table-column prop="crc_icon" label="图标" width="70" align="center">
                    <template #default="scope">
                        <el-image :src="scope.row['crc_icon']" style="width: 20px; height: 20px" />
                    </template>
                </el-table-column>
            </template>
        </Table>

        <!-- 表单 -->
        <PopupForm />
    </div>
</template>

<script setup lang="ts">
import { onMounted, provide, ref } from 'vue'
import baTableClass from '/@/utils/baTable'
import PopupForm from './popupForm.vue'
import Table from '/@/components/table/index.vue'
import TableHeader from '/@/components/table/header/index.vue'
import { defaultOptButtons } from '/@/components/table'
import { baTableApi } from '/@/api/common'
import { useI18n } from 'vue-i18n'
// import * as CurrencyConfig from '@/api/backend/siteManage/currencyConfig'

defineOptions({
    name: 'siteManage/currencyConfig',
})

const { t } = useI18n()
const tableRef = ref()
const optButtons: OptButton[] = defaultOptButtons(['edit', 'delete'])

/**
 * baTable 内包含了表格的所有数据且数据具备响应性，然后通过 provide 注入给了后代组件
 */
const baTable = new baTableClass(
    new baTableApi('/admin/siteManage.CurrencyConfig/'),
    {
        pk: 'crc_id',
        column: [
            { type: 'selection', align: 'center', operator: false },
            { label: t('序号'), prop: 'crc_id', align: 'center', width: 70, operator: false },
            { label: t('Code'), prop: 'crc_code', align: 'center', width: 70, operator: false },
            { label: t('货币名称'), prop: 'crc_name', align: 'center', width: 130 },
            { label: t('符号'), prop: 'crc_sign', align: 'center', width: 70, operator: false },
            { label: t('汇率（与美元）'), prop: 'crc_rate', align: 'center', width: 130, operator: false },
            { label: t('兑换加收比率'), prop: 'crc_exchange_rate', align: 'center', width: 130, operator: false },
            { render: 'slot', slotName: 'other', width: 70, operator: false },
            {
                label: t('State'),
                prop: 'crc_status',
                align: 'center',
                render: 'tag',
                custom: { '0': 'danger', '1': 'success' },
                replaceValue: { '0': t('Disable'), '1': t('Enable') },
                width: 70,
                operator: false,
            },
            {
                label: t('默认'),
                prop: 'crc_default',
                align: 'center',
                render: 'tag',
                custom: { '0': 'info', '1': 'primary' },
                replaceValue: { '0': t('否'), '1': t('是') },
                width: 70,
                operator: false,
            },
            { label: t('添加时间'), prop: 'crc_created_at', align: 'center', render: 'datetime', width: 130, operator: false },
            { label: t('更新时间'), prop: 'crc_updated_at', align: 'center', render: 'datetime', width: 130, operator: false },
            { label: t('备注'), prop: 'crc_memo', align: 'center', width: 130, operator: false },
            { label: t('Operate'), align: 'center', render: 'buttons', buttons: optButtons, operator: false },
        ],
        dblClickNotEditColumn: [undefined],
    },
    {
        defaultItems: { crc_rate: 100, crc_exchange_rate: 1, crc_default: 0, crc_status: '0', crc_order: 0, crc_created_at: 0, crc_updated_at: 0 },
    }
)

baTable.auth = (node: string) => {
    return true
}

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

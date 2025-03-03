<template>
    <div class="default-main ba-table-box">
        <el-alert class="ba-table-alert" v-if="baTable.table.remark" :title="baTable.table.remark" type="info" show-icon />

        <TableHeader
            :buttons="['refresh', 'add', 'edit', 'delete', 'comSearch', 'quickSearch', 'columnDisplay']"
            :quick-search-placeholder="t('Quick search placeholder', { fields: t('user.user.User name') + '/' + t('user.user.nickname') })"
        />

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

<script lang="ts" setup>
import { ref, provide } from 'vue'
import baTableClass from '/@/utils/baTable'
import PopupForm from './popupForm.vue'
import Table from '/@/components/table/index.vue'
import TableHeader from '/@/components/table/header/index.vue'
import { getList } from '/@/api/backend/siteManage/currencyConfig'
import type { TabsPaneContext } from 'element-plus'
import { ElMessage } from 'element-plus'
import { defaultOptButtons } from '/@/components/table'
import { baTableApi } from '/@/api/common'
import { useI18n } from 'vue-i18n'

defineOptions({
    name: 'siteManage/currencyConfig',
})

const { t } = useI18n()
const tableRef = ref()
const baTable = new baTableClass(new baTableApi('/admin/siteManage.CurrencyConfig/'), {
    column: [
        { type: 'selection', align: 'center', operator: false },
        { label: t('编号'), prop: 'crc_id', align: 'center', width: 70 },
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
            label: t('操作'),
            align: 'center',
            width: '130',
            render: 'buttons',
            buttons: defaultOptButtons(['edit', 'delete']),
            operator: true,
        },
    ],
    dblClickNotEditColumn: [undefined],
})

baTable.mount()
baTable.getIndex()

provide('baTable', baTable)
</script>

<style scoped lang="scss"></style>

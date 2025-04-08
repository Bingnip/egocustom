<template>
    <div class="default-main ba-table-box">
        <el-alert class="ba-table-alert" v-if="baTable.table.remark" :title="baTable.table.remark" type="info"
            show-icon />

        <!-- 表格顶部菜单 -->
        <!-- 自定义按钮请使用插槽，甚至公共搜索也可以使用具名插槽渲染，参见文档 -->
        <TableHeader :buttons="['refresh', 'add', 'delete', 'comSearch', 'quickSearch', 'columnDisplay']"
            :quick-search-placeholder="t('Quick search placeholder', { fields: t('marketingManage.couponRule.quick Search Fields') })">
        </TableHeader>

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
        name: 'marketingManage/couponRule',
    })

    const { t } = useI18n()
    const tableRef = ref()
    const optButtons: OptButton[] = defaultOptButtons(['edit', 'delete'])

    /**
     * baTable 内包含了表格的所有数据且数据具备响应性，然后通过 provide 注入给了后代组件
     */
    const baTable = new baTableClass(
        new baTableApi('/admin/marktingManage.couponRule/'),
        {
            pk: 'cr_id',
            column: [
                { type: 'selection', align: 'center', operator: false },
                { label: t('marketingManage.couponRule.cr_id'), prop: 'cr_id', align: 'center', width: 90, operator: false, sortable: 'custom' },
                { label: t('marketingManage.couponRule.cr_name'), prop: 'cr_name', align: 'center', operatorPlaceholder: t('Fuzzy query'), operator: 'LIKE', sortable: false },
                { label: t('marketingManage.couponRule.cr_start_at'), prop: 'cr_start_at', align: 'center', operator: 'egt', sortable: false },
                { label: t('marketingManage.couponRule.cr_end_at'), prop: 'cr_end_at', align: 'center', operator: 'elt', sortable: false },
                { label: t('marketingManage.couponRule.cr_status'), prop: 'cr_status', align: 'center', render: 'tag', operator: 'eq', sortable: false, replaceValue: {} },
                { label: t('marketingManage.couponRule.cr_priority'), prop: 'cr_priority', align: 'center', operator: false, sortable: false },
                { label: t('marketingManage.couponRule.cr_coupon_key'), prop: 'cr_coupon_key', align: 'center', operatorPlaceholder: t('Fuzzy query'), operator: 'LIKE', sortable: false },
                { label: t('marketingManage.couponRule.cr_discount_amount'), prop: 'cr_discount_amount', align: 'center', operator: false, sortable: false },
                { label: t('marketingManage.couponRule.cr_use_times'), prop: 'cr_use_times', align: 'center', operator: false, sortable: false },
                { label: t('marketingManage.couponRule.cr_coupon_type'), prop: 'cr_coupon_type', align: 'center', operator: false, sortable: false },
                { label: t('Operate'), align: 'center', width: 100, render: 'buttons', buttons: optButtons, operator: false },
            ],
            dblClickNotEditColumn: [undefined],
            defaultOrder: { prop: 'cr_id', order: 'desc' },
        },
        {
            defaultItems: { cr_id: null, cr_start_at: 0, cr_end_at: 0, cr_user_use: 0, cr_code_use: 0, cr_status: '0', cr_disrupt: 0, cr_priority: 0, cr_discount_amount: 0, cr_apply_for_atte: 0, cr_use_times: 0, cr_coupon_type: 0, cr_auto_generate: 0 },
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
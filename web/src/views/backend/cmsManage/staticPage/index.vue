<template>
    <div class="default-main ba-table-box">
        <el-alert class="ba-table-alert" v-if="baTable.table.remark" :title="baTable.table.remark" type="info"
            show-icon />

        <!-- 表格顶部菜单 -->
        <!-- 自定义按钮请使用插槽，甚至公共搜索也可以使用具名插槽渲染，参见文档 -->
        <TableHeader :buttons="['refresh', 'add', 'delete', 'comSearch', 'quickSearch', 'columnDisplay']"
            :quick-search-placeholder="t('Quick search placeholder', { fields: t('cmsManage.page.quick Search Fields') })">
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
        name: 'cmsManage/staticPage',
    })

    const { t } = useI18n()
    const tableRef = ref()
    const optButtons: OptButton[] = defaultOptButtons(['edit', 'delete'])

    /**
     * baTable 内包含了表格的所有数据且数据具备响应性，然后通过 provide 注入给了后代组件
     */
    const baTable = new baTableClass(
        new baTableApi('/admin/cmsManage.StaticPage/'),
        {
            pk: 'pb_id',
            column: [
                { type: 'selection', align: 'center', operator: false },
                { label: t('cmsManage.page.pb_id'), prop: 'pb_id', align: 'center', width: 80, operator: false, sortable: false },
                { label: t('cmsManage.page.pb_title'), prop: 'pb_title', align: 'center', operatorPlaceholder: t('Fuzzy query'), operator: 'LIKE', sortable: false },
                { label: t('cmsManage.page.pb_url_key'), prop: 'pb_url_key', align: 'center', width: 180, operatorPlaceholder: t('Fuzzy query'), operator: 'LIKE', sortable: false },
                {
                    label: t('State'),
                    prop: 'pb_status',
                    align: 'center',
                    render: 'tag',
                    custom: { '0': 'danger', '1': 'success' },
                    replaceValue: { '0': t('Disable'), '1': t('Enable') },
                    width: 70,
                    operator: '=',
                },
                { label: t('cmsManage.page.pb_created_at'), prop: 'pb_created_at', align: 'center', operator: false, render: 'datetime' },
                { label: t('cmsManage.page.pb_updated_at'), prop: 'pb_updated_at', align: 'center', operator: false, render: 'datetime' },
                { label: t('Operate'), align: 'center', width: 100, render: 'buttons', buttons: optButtons, operator: false },
            ],
            dblClickNotEditColumn: [undefined],
            defaultOrder: { prop: 'pb_id', order: 'desc' },
        },
        {
            defaultItems: { pb_status: 0, pb_created_at: 0, pb_updated_at: 0, pb_deleted_at: 0 },
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
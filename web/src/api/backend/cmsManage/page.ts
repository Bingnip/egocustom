import createAxios from '/@/utils/axios'

export const url = '/admin/cmsManage.StaticPage/'

export function getList() {
    return createAxios({ url: url + 'getList', method: 'post' })
}

export function removeRow(rowId: any) {
    const postData = { id: rowId }
    return createAxios({ url: url + 'removeRow', method: 'post', data: postData }, { showSuccessMessage: true })
}

export function saveForm(form: Object) {
    const postData = { form: form }
    return createAxios({ url: url + 'saveForm', method: 'post', data: postData }, { showSuccessMessage: true })
}

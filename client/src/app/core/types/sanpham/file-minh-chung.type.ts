export interface FileMinhChung{
    id:number,
    url?:string,
    created_at?:string,
    updated_at?:string
}

export interface CapNhatFileMinhChung{
    file:File
}


export interface FileVm{
    file_id:string,
    link_view:string
}
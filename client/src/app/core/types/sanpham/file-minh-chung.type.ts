export interface FileMinhChung{
    id:number,
    loaiminhchung?:string,
    url?:string,
    created_at?:string,
    updated_at?:string
}

export interface CapNhatFileMinhChung{
    loaiminhchung:string | null,
    url:string
}
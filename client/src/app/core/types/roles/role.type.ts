export interface Role{
    id:number,
    name:string,
    mavaitro:string,
    description?:string,
    created_at:string,
    updated_at:string,
}


export interface Permission{
    id:number,
    name:string,
    slug:string,
    description:string,
    created_at:string,
    updated_at:string
}

export interface CreateRole{
    name:string,
    description:string,
    permission_id:Array<number>
}

export interface UpdateRole{
    name:string,
    description:string,
    permission_id:Array<number>
}

export interface CreatePermission{
    name:string,
    slug:string,
    description:string | null
}

export interface UpdatePermission{
    name:string,
    slug:string,
    description:string | null,
}
export interface ApiResponse<T>{
    data: T,
    message: string
}

export interface PagingResponse<T>{
    totalPage:number,
    totalRecord:number,
    data:T
}
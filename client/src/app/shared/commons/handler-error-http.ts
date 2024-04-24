import {throwError} from "rxjs";

export function handleError(error: any){
    if(error?.status === 0){
        return throwError(() => "Có lỗi xảy ra, vui lòng thử lại sau")
    }

    return throwError(() => {
        if(error?.error?.message && error?.error?.httpStatusCode){
            return error.error.message
        }
        // if(error?.message){
        //     return error.message
        // }
        return "Có lỗi xảy ra, vui lòng thử lại sau"
    })
}
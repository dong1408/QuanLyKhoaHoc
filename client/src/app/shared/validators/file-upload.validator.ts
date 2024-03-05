import {MAX_FILE, MIME_TYPES} from "../commons/constants";

export const fileUploadValidator = (file:File):{success:boolean,message:string} => {
    if(file.size > MAX_FILE){
        return {
            success:false,
            message:"File bạn chọn vượt quá giới hạn (> 100mb)"
        };
    }
    if(!MIME_TYPES.includes(file.type)){
        return {
            success:false,
            message:"Chỉ chấp nhận định dạng file: pdf,docx"
        };
    }
    return {
        success:true,
        message:"OK"
    }
}
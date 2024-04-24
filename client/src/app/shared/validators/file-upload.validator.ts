import {MAX_FILE, MIME_TYPES} from "../commons/constants";
import {NzUploadFile} from "ng-zorro-antd/upload";

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

export const validateFileUpload = (file:NzUploadFile,fileList:NzUploadFile[]):string | null => {
    file.status = "uploading";
    const extension = file.name.split('.').pop()?.toLowerCase();

    const isTypeSuccess = extension === 'docx' || extension === 'pdf' || extension === 'xlsx' || extension === 'xls';

    if (!isTypeSuccess) {
        return 'Chỉ chấp nhận các file .docx, .pdf, .xlsx, .xls';
    }

    const isLessThan20MB = file.size! / 1024 / 1024 <= 20;

    if (!isLessThan20MB) {
        file.status = "error";
        return 'Chỉ chấp nhận file nhỏ hơn 20MB';
    }

    if (fileList.length >= 1) {
        file.status = "error";
        return 'Chỉ được upload 1 file';
    }

    return null;
}

export const validateFileImport = (file:NzUploadFile,fileList:NzUploadFile[]):string | null => {
    file.status = "uploading";
    const extension = file.name.split('.').pop()?.toLowerCase();

    const isTypeSuccess = extension === 'xlsx' || extension === 'xls';

    if (!isTypeSuccess) {
        return 'Chỉ chấp nhận các file .xlsx, .xls';
    }


    if (fileList.length >= 1) {
        file.status = "error";
        return 'Chỉ được upload 1 file';
    }

    return null;
}
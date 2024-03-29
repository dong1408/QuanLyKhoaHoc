import {NzUploadChangeParam, NzUploadFile} from "ng-zorro-antd/upload";
import {SanPhamTacGia, SanPhamTacGiaMerged} from "../../core/types/sanpham/vai-tro-tac-gia.type";

export const dateConvert = (date:string| null | undefined): string | null =>{
    if(date === null || date === undefined){
        return null;
    }

    const originalDate = new Date(date);

    const day = originalDate.getDate().toString().padStart(2, '0'); // Đảm bảo ngày có 2 chữ số, thêm số 0 nếu cần
    const month = (originalDate.getMonth() + 1).toString().padStart(2, '0'); // Đảm bảo tháng có 2 chữ số, thêm số 0 nếu cần
    const year = originalDate.getFullYear();

    const formattedDateString = `${year}-${month}-${day}`;

    return formattedDateString;
}


export const mergedUsers = (data:SanPhamTacGia[]):SanPhamTacGiaMerged[] =>{
    return data.reduce((acc:SanPhamTacGiaMerged[], curr) => {
        // Kiểm tra xem đã có phần tử với 'id_user' tương tự trong acc hay chưa
        const existingUser = acc.find(item => item.tacgia.id === curr.tacgia.id);
        if (!existingUser) {
            // Nếu không tìm thấy, thêm phần tử mới vào mảng kết quả
            acc.push({
                ...curr,
                vaitrotacgia:[curr.vaitrotacgia]
            });
        } else {
            // Nếu đã tồn tại, thêm giá trị 'vaitrotacgia' vào mảng tương ứng
            existingUser.vaitrotacgia.push(curr.vaitrotacgia);
        }
        return acc;
    }, []);
}

export const convertToFormData = (data:any, formData: FormData, prefix = ''):FormData => {
    for (const key in data) {
        if (Object.prototype.hasOwnProperty.call(data, key)) {
            const value = data[key];

            // Xây dựng tên trường dữ liệu
            const fieldName = prefix ? `${prefix}[${key}]` : key;

            if (key === 'fileminhchungsanpham[file]') {
                // Xử lý trường hợp đặc biệt
                formData.append(fieldName, value);
            }
            else if (typeof value === 'object' && value !== null && !Array.isArray(value)) {
                // Nếu giá trị là một đối tượng, tiếp tục đệ quy
                convertToFormData(value, formData, fieldName);
            } else if (Array.isArray(value)) {
                // Nếu giá trị là một mảng, duyệt qua từng phần tử và thêm vào FormData
                value.forEach((item: any, index: number) => {
                    convertToFormData({ [index]: item }, formData, fieldName);
                });
            } else {
                // Nếu giá trị không phải là đối tượng, thêm vào FormData
                formData.append(fieldName, value);
            }
        }
    }
    return formData
}
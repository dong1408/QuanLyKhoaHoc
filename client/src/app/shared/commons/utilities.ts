import {SanPhamTacGia} from "../../core/types/sanpham/vai-tro-tac-gia.type";

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


export const mergedUsers = (data:SanPhamTacGia[]) =>{
    return data.reduce((acc:any[], curr) => {
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
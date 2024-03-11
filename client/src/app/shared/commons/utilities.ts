export const dateConvert = (date:string): string =>{

    const originalDate = new Date(date);

    const day = originalDate.getDate().toString().padStart(2, '0'); // Đảm bảo ngày có 2 chữ số, thêm số 0 nếu cần
    const month = (originalDate.getMonth() + 1).toString().padStart(2, '0'); // Đảm bảo tháng có 2 chữ số, thêm số 0 nếu cần
    const year = originalDate.getFullYear();

    const formattedDateString = `${year}-${month}-${day}`;

    return formattedDateString;
}
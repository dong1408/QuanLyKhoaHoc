import {AbstractControl, ValidatorFn} from "@angular/forms";

export function validValuesValidator(validValues: string[]): ValidatorFn {
    return (control: AbstractControl): { [key: string]: any } | null => {
        const value = control.value;
        if(value === "" || value === null || value === undefined){
            return null;
        }
        if (validValues.includes(value)) {
            return null; // Giá trị hợp lệ
        } else {
            return { invalidValue: true }; // Giá trị không hợp lệ
        }
    };
}
import Swal from 'sweetalert2';

export default class SweetAlertService {
    static fireAlert(title, text, icon) {
        return Swal.fire({
            title: title,
            text: text,
            icon: icon,
        });
    }
}

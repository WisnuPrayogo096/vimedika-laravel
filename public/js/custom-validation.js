$.validator.methods.email = function (value, element) {
    return this.optional(element) || /[a-z]+@[a-z]+\.[a-z]+/.test(value);
};

$.validator.methods.phone_number = function (value, element) {
    if (this.optional(element)) return true;

    const regex = /^(?:\+62|62|0)8[1-9][0-9]{6,9}$/;
    if (!regex.test(value)) return false;

    const numbersOnly = value.replace(/\D/g, "");

    if (/^(\d)\1+$/.test(numbersOnly)) return false;

    return true;
};

$.validator.methods.pasport = function (value, element) {
    return this.optional(element) || /^[A-Z][0-9]{8}$/.test(value);
};

$.validator.methods.nik = function (value, element) {
    return (
        this.optional(element) ||
        /^\d{6}(0[1-9]|[12][0-9]|3[01]|4[1-9]|5[0-9])(0[1-9]|1[0-2])\d{2}\d{4}$/.test(
            value
        )
    );
};

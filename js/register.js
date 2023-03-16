$('#login').validate({
    rules: {
      email: {
        required: true,
        email: true,
      },
      password: {
        required: true,
        minlength: 3,
      },
      isrobot: {
        required: true
      },
      name: {
        required: true,
        minlength: 4,
      },
      phone: {
        required:true,
        number: true,
        minlength: 10,
      },
      birthday: {
        required: true,
        date: true,
      },
      address: {
        required: true,
      },
      repassword: {
        required: true,
        equalTo: password,
      }

    },
    messages: {
      email: {
        required: 'phải nhập email',
        email: 'chưa nhập đúng định dạng',
      },
      password: {
        required: 'chưa nhập mật khẩu',
        minlength: 'mật khẩu ít nhất 3 ký tự',
      },
      isrobot: {
        required: 'chưa xác nhận không phải robot',
      },
      name: {
        required: 'phải điền tên',
        minlength: 'tên phải có ít nhất 4 ký tự',
      },
      phone: {
        required: ' phải nhập số điện thoại',
        number: 'số điện thoại phải là số',
        minlength: 'số điện thoại ít nhất có 10 số',
      },
      birthday: {
        required: 'phải nhập ngày tháng năm sinh',
        date: 'phải là ngày có dạng mm/dd/yy',
      },
      address: {
        required: 'không được để trống',
      },
      repassword: {
        required: 'phải nhập lại password',
        equalTo: 'không giống với mật khẩu',
      }
    }
  });

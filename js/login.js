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
    }
  });
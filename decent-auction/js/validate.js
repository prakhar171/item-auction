  function checkPassword(str)
  {
    var re = (?=.{6,});
    return re.test(str);
  }

  function checkForm(form)
  {

    if(form.appl_pass.value != "" && form.appl_pass.value == form.appl_cpass.value) {
      if(!checkPassword(form.appl_pass.value)) {
        alert("The password you have entered is not valid!" + form.appl_pass.value);
        form.appl_pass.focus();
        return false;
      }
    } else {
      alert("Error: Please check that you've entered and confirmed your password!");
      form.appl_pass.focus();
      return false;
    }
    return true;
  }
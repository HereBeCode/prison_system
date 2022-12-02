function validateForm() {
  let fn = document.registerForm.firstName.value;
  let ln = document.registerForm.lastName.value;

  let regex = /^[&=_'+,<>]{0}[a-zA-Z- ]{1,50}$/;
  let result = regex.test(fn);
  console.log("Passed?: " + result);

  if (!result) {
    alert("Please enter a valid name");
    console.log("First Name Error");
    return false;
  }

  result = regex.test(ln);

  if (!result) {
    alert("Please enter a valid name");
    console.log("Last Name Error");
    return false;
  }

  return true;
}

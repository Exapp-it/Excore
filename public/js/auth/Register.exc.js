const registerComponent = {
  username: "",
  email: "",
  password: "",
  passwordConfirm: "",
  errors: {},
  message: "",
  csrfToken: "",
  sendRequest() {
    this.errors = {};
    const data = new URLSearchParams({
      username: this.username,
      email: this.email,
      password: this.password,
      passwordConfirm: this.passwordConfirm,
    });

    fetch("/register", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
        "X-CSRF-Token": this.csrfToken,
      },
      body: data,
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Ошибка. Код статуса: " + response.status);
        }
        return response.json();
      })
      .then((responseData) => {
        if (responseData.success) {
          this.info = responseData.info;
          if (responseData.redirect) {
            const elementToFadeOut = document.getElementById("content");
            if (elementToFadeOut) {
              elementToFadeOut.classList.add("fade-out");
              setTimeout(() => {
                window.location.href = responseData.redirect;
              }, 500);
            }
          }
        } else {
          this.info = responseData.info;
          this.errors = responseData.messages;
        }
      })
      .catch((error) => {
        console.error(error);
      });
  },
};

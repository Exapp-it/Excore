const loginComponent = {
  email: "",
  password: "",
  errors: {},
  message: "",
  csrfToken: "",
  sendRequest() {
    this.errors = {};
    const data = new URLSearchParams({
      email: this.email,
      password: this.password,
    });

    fetch("/login", {
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
        this.message = responseData.success
          ? responseData.message
          : responseData.errors.text ?? responseData.message;

        if (responseData.success && responseData.redirect) {
          const elementToFadeOut = document.getElementById("content");
          if (elementToFadeOut) {
            elementToFadeOut.classList.add("fade-out");
            setTimeout(() => {
              window.location.href = responseData.redirect;
            }, 500);
          }
        } else {
          this.errors = responseData.errors;
        }
      })
      .catch((error) => {
        console.error(error);
      });
  },
};

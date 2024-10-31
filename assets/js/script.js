class PeqiApp {
  /**
   * Construtor da classe
   */
  constructor() {
    this.debugMode();
    this.registerConsolInject();
    this.copyToClipboard();
    this.openPaymentLink();
    this.checkSubscriptionStatus();
    this.checkForm();
    this.registerIntlTelInput();
  }

  /**
   * Verificar Debug Mode
   */
  debugMode() {
    if (PEQIAPP_VAR.PEQI_DEBUG) {
      console.log("Debug Mode ativado!");
    }
  }

  /**
   * Console de injeção
   */
  registerConsolInject() {
    document.addEventListener("DOMContentLoaded", function () {
      console.log(`PeqiApp plugin carregado em ${PEQIAPP_VAR.PEQI_WEBSITE}!`);
    });
  }

  /**
   * Copiar para o clipboard
   */
  copyToClipboard() {
    document.addEventListener("DOMContentLoaded", function () {
      let copyButtons = document.querySelectorAll(
        "#ip-address-1, #ip-address-2, #ip-address-3, #ip-address-4"
      );

      copyButtons.forEach((button) => {
        button.addEventListener("click", function () {
          let ipAddressElement = document.getElementById(button.id);
          let ipAddress = ipAddressElement.textContent.trim();
          console.log("Endereço IP: ", ipAddress);
          let tempInput = document.createElement("textarea");
          tempInput.value = ipAddress;
          document.body.appendChild(tempInput);
          tempInput.select();
          document.execCommand("copy");
          document.body.removeChild(tempInput);
          button.classList.add("active");
        });
      });
    });
  }

  /**
   * Abertura do link de pagamento
   */
  openPaymentLink() {
    if (window.location.href.includes("page=peqiapp-awaiting")) {
      document.addEventListener("DOMContentLoaded", function () {
        var paymentUrl = PEQIAPP_VAR.payment_url;

        if (paymentUrl) {
          window.open(paymentUrl, "_blank");
        }
      });
    }
  }

  /**
   * Verificar pagamento
   */
  checkSubscriptionStatus() {
    if (window.location.href.includes("page=peqiapp-awaiting")) {
      document.addEventListener("DOMContentLoaded", function () {
        var apiURL = PEQIAPP_VAR.subscription_url;
        var peqiToken = PEQIAPP_VAR.token;

        function fetchSubscriptionStatus() {
          fetch(apiURL, {
            method: "GET",
            headers: {
              Authorization: "Token " + peqiToken,
            },
          })
            .then((response) => response.json())
            .then((data) => {
              var activeSubscription = data.results.find(
                (subscription) => subscription.status === "active"
              );
              if (activeSubscription) {
                window.location.href = "admin.php?page=peqiapp-success";
              } else {
                setTimeout(fetchSubscriptionStatus, 10000);
              }
            })
            .catch((error) => {
              console.error("Erro ao buscar assinatura: ", error);
              setTimeout(fetchSubscriptionStatus, 10000);
            });
        }
        fetchSubscriptionStatus();
      });
    }
  }

  /**
   * Verificação do formulário
   */
  checkForm() {
    if (window.location.href.includes("page=peqiapp-check-domain")) {
      document.addEventListener("DOMContentLoaded", function () {
        const results = PEQIAPP_VARS.validation_results;
        const resultsContainer = document.getElementById("validation-results");

        if (results && results.length > 0) {
          // Desabilita o botão de submit e muda o texto
          var submitButton = document.getElementById("submitButton");
          submitButton.textContent = "CHECKING...";
          submitButton.disabled = true;

          // Esconde o item
          var itemDiv = document.querySelector(".item");
          if (itemDiv) {
            itemDiv.style.display = "none";
          }

          let i = 0;
          let allSuccessful = true;
          let showIPInput = false;

          function showResult() {
            const result = results[i];
            const resultElement = document.createElement("div");
            const successDiv = document.getElementById("success");
            resultElement.classList.add("result-item");

            // Adiciona os ícones
            const icon = document.createElement("img");
            icon.classList.add("result-icon");
            if (result.status === "success") {
              icon.src = PEQIAPP_VARS.peqi_success_icon;
              icon.alt = "Success";
            } else {
              icon.src = PEQIAPP_VARS.peqi_error_icon;
              icon.alt = "Error";
              allSuccessful = false; // Marca como não completamente bem-sucedido se houver um erro
            }
            resultElement.appendChild(icon);

            // Adiciona as mensagens
            const message = document.createElement("p");
            message.textContent = result.message;
            message.classList.add("result-message");
            message.style.color = result.status === "success" ? "green" : "red";
            resultElement.appendChild(message);

            resultsContainer.appendChild(resultElement);

            // Verifica se possui CDN
            if (result.status === "alert") {
              showIPInput = true;

              const infoLabel = document.createElement("p");
              infoLabel.textContent =
                "Looks like your website is already using a CDN, so we need the origin IP from your hosting provider:";
              infoLabel.style.fontSize = "16px";
              infoLabel.style.textAlign = "center";

              const divInput = document.createElement("div");
              divInput.classList.add("div-inputs");

              const containerInput = document.createElement("div");
              containerInput.classList.add("container-input");

              const subcontainerInput = document.createElement("div");
              subcontainerInput.classList.add("subcontainer-input");

              const ipLabel = document.createElement("label");
              ipLabel.classList.add("label-input");
              ipLabel.textContent = "IP Address";

              // Criar o input
              const ipInput = document.createElement("input");
              ipInput.classList.add("input");
              ipInput.type = "text";
              ipInput.id = "server-ip";
              ipInput.placeholder = "127.0.0.1";
              ipInput.required = true;

              // Criar o botão
              const submitIpButton = document.createElement("button");
              submitIpButton.textContent = "SUBMIT IP";
              submitIpButton.classList.add("primary-button");
              submitIpButton.style.width = "176px";
              submitIpButton.onclick = function () {
                if (ipInput.value.trim() === "") {
                  ipInput.reportValidity();
                  return;
                }

                successDiv.style.display = "block";
                // Definir o IP inserido
                var cdnIp = document.getElementById("server-ip").value;
                var ipAddressField = document.querySelector(
                  'input[name="ip_address"]'
                );
                ipAddressField.value = cdnIp;

                // Oculta o botão e o input após submissão
                resultsContainer.style.display = "none";
                submitButton.textContent = "DONE";
              };

              subcontainerInput.appendChild(ipLabel);
              subcontainerInput.appendChild(ipInput);
              containerInput.appendChild(subcontainerInput);

              divInput.appendChild(containerInput);
              divInput.appendChild(submitIpButton);

              resultsContainer.appendChild(infoLabel);
              resultsContainer.appendChild(divInput);
            }

            i++;
            if (i < results.length) {
              setTimeout(showResult, 1000);
            } else {
              setTimeout(() => {
                const finalMessage = document.createElement("p");
                if (allSuccessful && !showIPInput) {
                  finalMessage.textContent =
                    "Your website is eligible for being peqified!";
                  finalMessage.style.color = "green";
                  finalMessage.style.textAlign = "center";
                  successDiv.style.display = "block";
                  submitButton.textContent = "DONE";
                } else if (!allSuccessful && !showIPInput) {
                  finalMessage.textContent =
                    "Some checks failed. Please review the errors above.";
                  finalMessage.style.color = "red";
                  finalMessage.style.textAlign = "center";
                  submitButton.textContent = "CHECK";
                  submitButton.disabled = false;
                }
                finalMessage.style.fontSize = "20px";
                resultsContainer.appendChild(finalMessage);
              }, 1000);
            }
          }
          showResult();
        }
      });
    }
  }

  /**
   * Código do país
   */
  registerIntlTelInput() {
    if (window.location.href.includes("page=peqiapp-register")) {
      document.addEventListener("DOMContentLoaded", function () {
        var phoneInput = "#peqi_phone";
        var countryCodePhone = "#peqi_country_code_phone";

        var input = document.querySelector(phoneInput);
        var iti = window.intlTelInput(input, {
          formatOnDisplay: true,
          initialCountry: "BR",
          preferredCountries: ["br", "ar", "us"],
          utilsScript:
            "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js",
        });

        function addPhoneMask() {
          var selectedCountryData = iti.getSelectedCountryData();
          var placeholder = input.placeholder.replace(/[0-9]/g, "0");
          var currentValue = input.value.replace(/\D/g, "");
          var maskedValue = "";
          var placeholderIndex = 0;

          for (var i = 0; i < currentValue.length; i++) {
            if (placeholderIndex >= placeholder.length) {
              break;
            }
            if (placeholder[placeholderIndex] === "0") {
              maskedValue += currentValue[i];
              placeholderIndex++;
            } else {
              maskedValue += placeholder[placeholderIndex];
              placeholderIndex++;
              i--;
            }
          }

          input.value = maskedValue;

          var fullNumber = selectedCountryData.dialCode + currentValue;
          document.querySelector(countryCodePhone).value = fullNumber;
        }

        input.addEventListener("input", addPhoneMask);

        iti.promise.then(function () {
          var event = new Event("countrychange");
          input.dispatchEvent(event);
        });

        input.addEventListener("countrychange", function () {
          addPhoneMask();
        });
      });
    }
  }
}

new PeqiApp();

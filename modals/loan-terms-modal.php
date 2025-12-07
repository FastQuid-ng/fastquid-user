    <div class="modal fade" id="loanTermsModal" tabindex="-1" aria-labelledby="loanTermsModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content overflow-hidden">
          <div class="modal-header pb-0 border-0">
            <h1 class="modal-title h4" id="loanTermsModalLabel">Accept To Continue</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p class="mb-2">
              Please be informed that in the event of default on your loan payments, Fastquid reserves the right to recover the outstanding loan amount directly from your next salary through your employer.
            </p>
            <p class="mb-2">
              This action will be taken in accordance with the terms and conditions agreed upon in your loan agreement. We urge you to ensure timely repayment of your loan. Thank you.
            </p>
            <p class="mb-3">
              Click <a href="https://fastquid.ng/terms-of-use/" target="_blank">here</a> to learn more about our terms of service.
            </p>

            <form class="vstack gap-6">
              <div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="check_example">
                  <label class="form-check-label" for="check_example">
                    I agree and wish to continue with my loan request
                  </label>
                </div>
              </div>
              <button type="button" class="btn btn-primary w-100" id="continueBtn" disabled>
                Continue to loan application
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script>
        const checkbox = document.getElementById('check_example');
        const continueBtn = document.getElementById('continueBtn');

        // Enable button only when checkbox is checked
        checkbox.addEventListener('change', function() {
            continueBtn.disabled = !this.checked;
        });

        // Redirect when button is clicked
        continueBtn.addEventListener('click', function() {
            window.location.href = 'loan-application'; // change this URL
        });
    </script>
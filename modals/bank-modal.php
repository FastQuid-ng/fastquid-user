<div class="modal fade" id="bankAccountModal" tabindex="-1" aria-labelledby="bankAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content overflow-hidden">
            <div class="modal-header pb-0 border-0">
                <h1 class="modal-title h4" id="bankAccountModalLabel">Add Bank Account</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="bankForm">
                    <div class="row g-2">
                        
                        <!-- Hidden user_id field, value set from session -->
                        <div class="col-sm-12" style="display: none;">
                            <input type="text" class="form-control" name="user_id" id="user_id" value="<?= $_SESSION['user_id'] ?>" required>
                        </div>

                        <!-- Bank Select -->
                        <div class="col-sm-12">
                            <label class="form-label">Bank</label>
                            <select class="form-select" id="bankSelect" name="bank_code" required>
                                <option disabled selected value="">Select Bank</option>
                            </select>
                        </div>

                        <!-- Bank Name (Hidden) -->
                        <div class="col-sm-12">
                            <input type="hidden" name="bank_name" id="bankNameHidden">
                        </div>

                        <!-- Account Number -->
                        <div class="col-sm-12">
                            <label class="form-label">Account Number</label>
                            <input type="text" class="form-control" maxlength="20" id="accountNumber" name="account_number" required>
                        </div>

                        <!-- Account Name -->
                        <div class="col-sm-12">
                            <label class="form-label">Account Name</label>
                            <input type="text" class="form-control" id="accountName" disabled>
                            <!-- Hidden input to actually send the account name -->
                            <input type="hidden" name="account_name" id="accountNameHidden">
                        </div>

                        <!-- Primary Account Checkbox -->
                        <div class="col-sm-12">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="is_primary" id="isPrimary" value="1" checked>
                                <label class="form-check-label" for="isPrimary">
                                    Set as primary account
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-sm-12 mt-4">
                            <button type="submit" class="btn btn-dark w-100" id="submitBankBtn" disabled>Add Bank Account</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal for Adding Class -->
<div class="modal fade" id="addClassModal" tabindex="-1" aria-labelledby="addClassModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addClassModalLabel">Add New Class</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="{{ route('addClass') }}" method="POST" id="addClassForm" onsubmit="return validateForm()">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Class Name</label>
        <div class="input-wrapper">
            <input type="text" required class="form-control" id="name" name="name" autocomplete="off">
            <div class="loader-container d-none" id="loadingIndicator">
                <div class="custom-loader"></div>
            </div>
        </div>
        <div class="alert alert-danger d-none mt-2" id="addError"></div>
    </div>
    <button type="submit" class="btn-add">Add Class</button>
</form>


            </div>
        </div>
    </div>
</div>
<style>
    .input-wrapper {
        position: relative;
    }

    .loader-container {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        pointer-events: none;
    }

    .custom-loader {
        width: 20px;
        height: 20px;
        border: 2px solid #f3f3f3;
        border-top: 2px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<script>
    let debounceTimer;
    let lastCheckedName = '';
    const inputField = document.getElementById('name');
    const errorDiv = document.getElementById('addError');
    const loadingIndicator = document.getElementById('loadingIndicator');

    inputField.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(checkAddClassName, 300); // 300ms delay
    });

    function normalizeClassName(name) {
        return name.trim().replace(/\s+/g, ' ');
    }

    async function checkAddClassName() {
        const className = normalizeClassName(inputField.value);

        // Clear previous error state
        errorDiv.classList.add('d-none');
        inputField.classList.remove('is-invalid');

        // Check if the class name is empty or unchanged
        if (className.length === 0 || className === lastCheckedName) {
            return;
        }

        lastCheckedName = className;

        // Show loading indicator
        loadingIndicator.classList.remove('d-none');

        try {
            const response = await fetch("{{ route('checkClassName') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ class_name: className })
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();

            if (data.exists) {
                errorDiv.textContent = "The class name has already been taken.";
                errorDiv.classList.remove('d-none');
                inputField.classList.add('is-invalid');
            }
        } catch (error) {
            console.error('Error:', error);
            errorDiv.textContent = "An error occurred while checking the class name.";
            errorDiv.classList.remove('d-none');
        } finally {
            loadingIndicator.classList.add('d-none'); // Hide loading indicator
        }
    }

    function validateForm() {
        const className = normalizeClassName(inputField.value);

        // Check if the class name is empty
        if (className.length === 0) {
            errorDiv.textContent = "Please enter a class name.";
            errorDiv.classList.remove('d-none');
            inputField.classList.add('is-invalid');
            return false;
        }

        // Check if there is an error message displayed
        if (!errorDiv.classList.contains('d-none')) {
            return false;
        }

        return true;
    }
</script>
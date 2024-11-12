<!-- Modal for Adding Student -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStudentModalLabel">Add New Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('addStudent') }}" method="POST" id="addStudentForm">
                    @csrf
                    <div id="student-name-container">
                        <div class="mb-3 student-name-field">
                            <label for="name" class="form-label">Student Name</label>
                            <input type="text" class="form-control" name="names[]" required autocomplete="off" oninput="handleInputFields()">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="class_id" class="form-label">Assign to Class</label>
                        <select class="form-control" id="class_id" name="class_id" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn-add">Add Students</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function handleInputFields() {
        const container = document.getElementById('student-name-container');
        const inputs = container.getElementsByTagName('input');
        const lastInput = inputs[inputs.length - 1];
        const secondToLastInput = inputs[inputs.length - 2];

        // Check if last input has a value and create a new field if so
        if (lastInput.value.trim() !== "") {
            const newField = document.createElement('div');
            newField.classList.add('mb-3', 'student-name-field');
            newField.innerHTML = `
                <label class="form-label">Student Name</label>
                <input type="text" class="form-control" name="names[]" autocomplete="off" oninput="handleInputFields()">
            `;
            container.appendChild(newField);
        }

        // Remove the last input if the second-to-last input is empty
        if (inputs.length > 1 && secondToLastInput.value.trim() === "") {
            container.removeChild(lastInput.closest('.student-name-field'));
        }
    }
</script>

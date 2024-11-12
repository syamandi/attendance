<!-- Rename Class Modal -->
<div class="modal fade" id="renameClassModal{{$class->id}}" tabindex="-1" aria-labelledby="addClassModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addClassModalLabel">Rename Class</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('editClass', $class->id) }}" method="POST" id="renameClassForm{{$class->id}}">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label for="renameClass" class="form-label">Rename Class Name</label>
                        <input type="text" class="form-control" id="renameClass{{$class->id}}" name="renameClass" value="{{$class->class_name}}" required oninput="checkClassName({{ $class->id }})" autocomplete="off">
                    </div>
                    <div class="alert alert-danger d-none" id="renameError{{$class->id}}"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button><div></div><div></div>
                <button type="button" class="btn btn-success" onclick="submitRenameForm({{ $class->id }})">Rename</button>
            </div>
        </div>
    </div>
</div>


<!-- Delete Class Modal -->
<div class="modal fade" id="deleteClassModal{{$class->id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Delete Class</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this class?</p>
      </div>
      <form action="{{ route('deleteClass', $class->id) }}" method="POST" id="deleteClassForm{{$class->id}}">
                    @csrf
                    @method('PATCH')
                  
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button><div></div><div></div>
        <button type="submit" class="btn btn-danger">Delete</button>
      </div> 
     </form>
    </div>
  </div>
</div>

<script>
  function checkClassName(classId) {
    let className = document.getElementById('renameClass' + classId).value;
    
    fetch(`/check-class-name`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ class_name: className, class_id: classId })
    })
    .then(response => response.json())
    .then(data => {
        let errorDiv = document.getElementById('renameError' + classId);
        if (data.exists) {
            errorDiv.innerHTML = 'This class name has already been taken.';
            errorDiv.classList.remove('d-none');
            
        } else {
            errorDiv.classList.add('d-none');
        }
    })
    .catch(error => console.error('Error:', error));
}

function submitRenameForm(classId) {
    const errorDiv = document.getElementById('renameError' + classId);
    
    // Check if there is already an error message
    if (errorDiv.classList.contains('d-none')) {
        // Submit the form
        document.getElementById('renameClassForm' + classId).submit();
    }
}


</script>
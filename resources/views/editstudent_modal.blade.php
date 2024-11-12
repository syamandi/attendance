<!-- Rename Student Modal -->
<div class="modal fade" id="renameStudentModal{{$student->id}}" tabindex="-1" aria-labelledby="renameStudentModalLabel{{$student->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="renameStudentModalLabel{{$student->id}}">Edit Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('editStudent', $student->id) }}" method="POST" id="renameStudentForm{{$student->id}}">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label for="renameStudent{{$student->id}}" class="form-label">Edit Student Name</label>
                        <input type="text" class="form-control" id="renameStudent{{$student->id}}" name="renameStudent" value="{{$student->name}}" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="class_id{{$student->id}}" class="form-label">Assign to Class</label>
                        <select class="form-control" id="class_id{{$student->id}}" name="class_id" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ $class->id == $student->class_id ? 'selected' : '' }}>
                                {{ $class->class_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button><div></div><div></div>
                <button type="submit" class="btn btn-success">Edit</button>
            </div> 
        </form>
        </div>
    </div>
</div>

<!-- Delete Student Modal -->
<div class="modal fade" id="deleteStudentModal{{$student->id}}" tabindex="-1" aria-labelledby="deleteStudentModalLabel{{$student->id}}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteStudentModalLabel{{$student->id}}">Delete Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this student?</p>
      </div>
      <form action="{{ route('deleteStudent', $student->id) }}" method="POST" id="deleteStudentForm{{$student->id}}">
        @csrf
        @method('PATCH') <!-- Use DELETE method for deletion -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button><div></div><div></div>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>

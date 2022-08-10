<div class="card">
  <div class="card-body">
    <h5>Chatpic Lookup</h5>
    <div class="row">
  <form action="/admin/dashboard/chatpics/view" method="POST">
      <div class="col-8 col-sm-12 col-xl-8 my-auto">
        <div class="d-flex d-sm-block d-md-flex align-items-center">
        <label for="mid">ID: </label>
    <input type="text" class="form-control" id="mid" name="mid" aria-describedby="midHelp" placeholder="Enter Chatpic ID">
        </div>
        <small id="midHelp" class="form-text text-muted">Enter the id for the chatpic you would like to view.</small>
      </div>
      <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
</form>
    </div>
  </div>
</div>

<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-danger">
  {ERROR}
</div>
<!-- END: error -->
<form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post" class="confirm-reload" enctype="multipart/form-data">
  <input type="hidden" name="id" value="{POST.id}">
  <div class="row mb-3">
      <div class="col-md-12 mb-3">
          <label class="form-label fw-bold"><strong>{LANG.name}</strong></label>
          <input type="text" name="name" class="form-control shadow-none" required value="{POST.name}">
      </div>
      <div class="col-md-12 mb-3">
          <label class="form-label fw-bold"><strong>{LANG.area}</strong></label>
          <input type="number" min="1" name="area" class="form-control shadow-none" required value="{POST.area}">
      </div>
      <div class="col-md-12 mb-3">
          <label class="form-label fw-bold"><strong>{LANG.price}</strong></label>
          <input type="number" min="1" name="price" class="form-control shadow-none" required value="{POST.price}">
      </div>
      <div class="col-md-12 mb-3">
          <label class="form-label fw-bold"><strong>{LANG.quantity}</strong></label>
          <input type="number" min="1" name="quantity" class="form-control shadow-none" required value="{POST.quantity}">
      </div>
      <div class="col-md-12 mb-3">
          <label class="form-label fw-bold"><strong>{LANG.adult}</strong></label>
          <input type="number" min="1" name="adult" class="form-control shadow-none" required value="{POST.adult}">
      </div>
      <div class="col-md-12 mb-3">
          <label class="form-label fw-bold"><strong>{LANG.children}</strong></label>
          <input type="number" min="1" name="children" class="form-control shadow-none" required value="{POST.children}">
      </div>
      <div class="col-24 mb-3">
          <label class="form-label fw-bold"><strong>{LANG.features}</strong></label>
          <div class="row">
              <!-- BEGIN: features -->
              <div class="col-md-3 mb-1">
                  <label>
                      <input type="checkbox" name="features[]" value="{FEATURES.key}" {FEATURES.checked} class="form-check-input shadow-none">
                      {FEATURES.title}
                  </label>
              </div>
              <!-- END: features -->
          </div>
      </div>
      <div class="col-24 mb-3">
          <label class="form-label fw-bold"><strong>{LANG.facilities}</strong></label>
          <div class="row">
              <!-- BEGIN: facilities -->
              <div class="col-md-3 mb-1">
                  <label>
                      <input type="checkbox" name="facilities[]" value="{FACILITIES.key}" {FACILITIES.checked} class="form-check-input shadow-none">
                      {FACILITIES.title}
                  </label>
              </div>
              <!-- END: facilities -->
          </div>
      </div>
      <div class="col-24 mb-3">
          <label class="form-label fw-bold"><strong>{LANG.description}</strong></label>
          <textarea name="description" rows="4" class="form-control shadow-none" required>{POST.description}</textarea>
      </div>
  </div>
  <div><br/></div>
  <div class="form-group row text-center">
    <button type="submit" class="btn btn-primary" value="1" name="submit" value="{LANG.save}">{LANG.save}</button>
  </div>
</form>
<!-- END: main -->

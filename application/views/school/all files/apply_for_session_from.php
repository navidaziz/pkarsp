          <div class="row" style="padding: 10px 25px;">
            <!-- col-md-offset-1 -->
            <div class="col-md-12">

              <?php echo validation_errors(); ?>
              <form class="form-horizontal" method="post" enctype="multipart/form-data" id="role_form" action="<?php echo base_url('school/apply_session'); ?>">
                <input type="hidden" name="session_id" value="<?php echo $session_id; ?>" <table class="table">
                <tr>
                  <td>
                    <h3 style="text-align: center;">
                      Select application type for session <?php echo $session->sessionYearTitle; ?><br />
                      <label class="radio-inline ">
                        <input required type="radio" name="reg_type_id" class="flat-red" value="2" />
                        <h4 style="display: inline; margin-left:10px">Renewal</h4>
                      </label>
                      <br />
                      <label class="radio-inline ">
                        <input required type="radio" name="reg_type_id" class="flat-red" value="4" />
                        <h4 style="display: inline; margin-left:10px"> Up-Gradation And Renewal </h4>
                      </label>
                      <br />
                      <br />
                      <input name="apply" value="Apply for session <?php echo $session->sessionYearTitle; ?>" type="submit" class="btn btn-success" />
                    </h3>
                  </td>
                </tr>
                </table>

              </form>

            </div>
          </div>
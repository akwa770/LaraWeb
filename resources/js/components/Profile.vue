<style>

    .widget-user-header{
        background-position: center center;
        background-size: cover;
        height: 300px !important ;
        filter: opacity(30%);
    }

</style>

<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-3">
            <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header text-white" style="background-image:url('./images/profile-bg.jpg');">
                <h3 class="widget-user-username">{{ this.form.name }}</h3>
                <h5 class="widget-user-desc">{{ this.form.bio }}</h5>
              </div>
              <div class="widget-user-image">
                <img class="img-circle" :src="getProfilePhoto()" alt="User Avatar">
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                        <div class="description-block">
                        <h5 class="description-header">3,200 </h5>
                        <span class="description-text">SALES</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                        <h5 class="description-header">13,000</h5>
                        <span class="description-text">FOLLOWERS</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4">
                        <div class="description-block">
                        <h5 class="description-header">35</h5>
                        <span class="description-text">PRODUCTS</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                </div>

                <!-- Form -->

                 <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Activity</a></li>
                  <li class="nav-item"><a class="nav-link active show" href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane" id="activity">
                    <!-- Post -->
                    <div class="post">
                      <p>User Activity</p>

                    </div>
                    <!-- /.post -->
                
                  </div>
                  <!-- /.tab-pane -->

        
         
         

                  <div class="tab-pane active show" id="settings">
                    <form class="form-horizontal">
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">Name</label>

                        <div class="col-sm-10">
                          <input v-model="form.name" type="email" class="form-control" id="inputName" placeholder="Name" :class="{ 'is-invalid': form.errors.has('name') }">
                          <has-error :form="form" field="name"></has-error>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                        <div class="col-sm-10">
                          <input v-model="form.email" type="email" class="form-control" id="inputEmail" placeholder="Email" :class="{ 'is-invalid': form.errors.has('email') }">
                          <has-error :form="form" field="email"></has-error>
                        </div>
                      </div>
                      <!-- <div class="form-group">
                        <label for="inputName2" class="col-sm-2 control-label">Name</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputName2" placeholder="Name">
                        </div>
                      </div> -->
                      <div class="form-group">
                        <label for="inputExperience" class="col-sm-2 control-label">Experience</label>

                        <div class="col-sm-10">
                          <textarea v-model="form.experience" class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                          <has-error :form="form" field="experience"></has-error>
                        </div>
                      </div>
                      <!-- <div class="form-group">
                        <label for="position" class="col-sm-2 control-label">Position</label>

                        <div class="col-sm-10">
                          <input  v-model="form.position" type="text" class="form-control" id="position" name="position" placeholder="Position">
                          <has-error :form="form" field="position"></has-error>
                        </div>
                      </div> -->
                      <div class="form-group">
                        <label for="bio" class="col-sm-2 control-label">Biography</label>

                        <div class="col-sm-10">
                          <input  v-model="form.bio" type="text" class="form-control" id="bio" name="bio" placeholder="Biography">
                          <has-error :form="form" field="bio"></has-error>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="photo" class="col-sm-2 control-label">Profile Photo</label>
                        <div class="col-sm-12">
                            <input type="file" @change="updateProfile" name="photo" class="form-input">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button @click.prevent="updateInfo" type="submit" class="btn btn-success">Update</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
          data(){
            return{
               form: new Form({
                    id: '',
                    name: '',
                    email: '',
                    password: '',
                    type: '',
                    // position: '',
                    bio: '',
                    photo: ''
                })
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            getProfilePhoto(){
              let photo = (this.form.photo.length > 100) ? this.form.photo : "images/profile/" + this.form.photo;
              return photo;
            },
            updateInfo(){
                this.$Progress.start();
                if (this.form.password == '') {
                  this.form.password == undefined;
                }
                this.form.put('api/profile')
            .then(()=>{
                this.$Progress.finish();
                swal(
                    'Updated!',
                    'the User info has been updated.',
                    'success'
                    )
            })
            .catch(()=>{
              this.$Progress.fail();

            });
            },
            updateProfile(e){
              // console.log('uploading');
                let file = e.target.files[0];
                let reader = new FileReader();
                console.log(file);
                
                if (file['size'] < 3000000) {
                  
                  reader.onloadend = (file) => {
                    console.log('RESULT', reader.result)
                    this.form.photo = reader.result;
                  }
                    reader.readAsDataURL(file);
                } else {
                  swal({
                    type: 'error',
                    title: 'Oops...',
                    text: 'You are uploading a large file!',
                  })
                }

            }
        },
        created() {
            axios.get('api/profile').then(({data}) => (this.form.fill(data)));
        },

    }
</script>

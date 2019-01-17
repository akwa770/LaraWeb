<template>
  <div class="container">
    <div class="row justify-content-center mt-4">
      <div class="col-md-8" v-if="$gate.isAdmin() || $gate.isAuthor()">
        <div class="card card-widget widget-user-2">
          <!-- Add the bg color to the header using any of the bg-* classes -->
          <div class>
            <!-- <div class="widget-user-image">
                  <img class="img-circle elevation-2" src="" alt="User Avatar">
            </div>-->
            <!-- /.widget-user-image -->
            <!-- <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;" ></h4> -->
            <h3 class="widget-user-username">All Data</h3>
            <h5 class="widget-user-desc">Lead Developer</h5>
          </div>
          <div class="card-footer p-0">
            <ul class="nav flex-column">
              <li class="nav-item">
                <!-- <a href="#" > -->
                <router-link to="/posts" class="nav-link">Posts
                  <span class="float-right badge bg-success">{{ this.postsCount }}</span>
                </router-link>
                <!-- </a> -->
              </li>
              <li class="nav-item">
                <!-- <a href="#" class="nav-link">Users -->
                <router-link to="/users" class="nav-link">Users
                  <span class="float-right badge bg-success">{{ this.usersCount }}</span>
                </router-link>
                <!-- </a> -->
              </li>
              <!-- <li class="nav-item">
                <a href="#" class="nav-link">Completed Projects
                  <span class="float-right badge bg-success">12</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">Followers
                  <span class="float-right badge bg-danger">842</span>
                </a>
              </li> -->
            </ul>
          </div>
        </div>
      </div>
        <div class="not-found" v-if="!$gate.isAdmin() && !$gate.isAuthor()">
           <not-found /> 
        </div>  

    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      postsCount: null,
      usersCount: null
    };
  },
  methods: {
    loadPosts() {
        if(this.$gate.isAdmin() || this.$gate.isAuthor()){
            axios.get("post").then(({ data }) => { this.postsCount = data.posts_count; });
        }
    },
    loadUsers() {
        if(this.$gate.isAdmin() || this.$gate.isAuthor()){
            axios.get("api/user").then(({ data }) => { this.usersCount = data.users_count; });
        }
    },
  },
        mounted() {
            this.loadPosts();
            this.loadUsers();
          console.log("Component mounted.");
        //   console.log(this.postsCount);
          console.log(this.usersCount);
        }
};
</script>

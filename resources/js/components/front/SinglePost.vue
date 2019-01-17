<style>
img.card-img-top {
  object-fit: cover;
  object-position: 50% 50%;
  height: 300px;
}
</style>

<template>
  <div class="container">
    <header-image/>
    <div class="row">
      <div class="col-md-12 ml-auto mr-auto">
        <h2 class="title text-center mt-4">{{ this.post.title }}</h2>
        <!-- <h2 v-if="!this.post.title" class="title text-center mt-4">Post not found!</h2> -->
        <!-- <h2 class="title text-center mt-4">{{ singlepost.title }}</h2> -->

        <br>
        <div class="row justify-content-center">
          <div class="col-lg-12">
            <div class="card card-plain card-blog">
              <img v-bind:src="'./images/'+image" class="card-img-top" alt="title">

              <div class="card-body mt-4">
                <h2 class="card-title text-center">
                  {{ this.post.title }}
                </h2>
                <!-- <h6 class="category">Last updated: <span class="text-info">{{ post.created_at | myDate }}</span></h6> -->
                <p class="card-text">
                  <small class="text-muted">{{ post.created_at | myDate }}</small>
                </p>

                <p class="card-description text-muted">{{ this.post.body | upperCase }}</p>
                <!-- <p class="card-description text-muted">{{singlepost.body}}</p> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      post: {
        id: this.$route.params.id
      },
      // image: "./images/"+this.post.photo
      image:'',
      // title: this.post.title
    };
  },
  methods: {
    loadPost(id = this.post.id) {
      axios
        .get("post/" + id)
        .then(({ data }) => (this.post = data))
        .then(()=> this.image = this.post.photo)
        .catch(() => {
          console.log("post no found...");
          
        });
    }
  },
  created() {
    this.loadPost();
  }
};
</script>

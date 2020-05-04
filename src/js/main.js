const app = new Vue({
  el: "#app",
  data: {
    baseUri: 'http://localhost/includes/api',
    users: [],
    editingId: null,
    editData: null,
    create: false,
    newUser: {
      name: null,
      school_name: null,
      gender: "M",
      age: null
    },
    deleteTrigger: false,
    deleteId: null
  },
  created() {
    this.initFun();
  },
  methods: {
    prepareDelete(id) {
      this.deleteId = id;
      this.deleteTrigger = true;
    },
    async initFun() {
      try {
        const res = await fetch(`${
                    this.baseUri
                }/user.php`)
        const data = await res.json()
        this.users = data.data
      } catch (err) {
        console.log(err);
      }
    },
    editUser(user) {
      this.editingId = user.id
      this.editData = user
    },
    async updateUser(id) {
      try {
        const res = await fetch(`${
          this.baseUri
        }/user.php?id=${id}`, {
          method: "PUT",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify(this.editData)
        });
        const data = await res.json();
        console.log(data);
        this.initFun();
        this.cancelEdit();
      } catch (err) {
        console.log(err);
      }
    },
    cancelEdit() {
      this.editingId = null
      this.editData = null
    },
    async createUser() {
      try {
        this.newUser.age = Number(this.newUser.age)
        const res = await fetch(`${
          this.baseUri
        }/user.php`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify(this.newUser)
        });
        console.log({res});
        this.resetForm();
        this.initFun();
        this.create = false
      } catch (err) {
        console.log(err);
      }
    },
    async deleteUser() {
      try {
        await fetch(`${
          this.baseUri
        }/user.php?id=${this.deleteId}`, {
          method: "DELETE",
          headers: {
            "Content-Type": "application/json"
          },
        });
        this.initFun();
        this.deleteId = null;
        this.deleteTrigger = false;
      } catch (err) {
        console.log(err);
      }
    },
    resetForm() {
      const newUser = {
        name: null,
        school_name: null,
        gender: "M",
        age: null
      };
      this.newUser = newUser;
    }
  }
});
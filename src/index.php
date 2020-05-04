<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Document</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="./css/main.css">
</head>

<body>
  <div id="app">
    <nav class="nav-bar">
      <div class="spacer"></div>
      <div class="action">
        <button @click="create=true" :class="create ? 'active' : ''">enroll</button>
        <button @click="create=false" :class="!create ? 'active' : ''">enrolled list</button>
      </div>
    </nav>
    <div class="delete-dialog" v-if="deleteTrigger">
      <div class="closing-part"></div>
      <div class="delete-card">
        <h3>do you really want to delete this user</h3>
        <button @click="deleteTrigger=false">cancel</button>
        <button @click="deleteUser()" class="delete">delete</button>
      </div>
    </div>
    <div class="wrapper">
      <div v-if="!create" class="container">
        <h1 class="title">User Collection</h1>
        <div class="table-card">
          <table>
            <thead>
              <th>ID</th>
              <th>Name</th>
              <th>School Name</th>
              <th>Gender</th>
              <th>Age</th>
              <th class="action">action</th>
            </thead>
            <tbody v-if="users.length > 0">
              <tr v-for="(item) in users" :key="item.id">
                <td v-for="(value, key) in item" :id="key">
                  <span v-if="key == 'id'">{{value}}</span>
                  <span v-if="key !== 'id' && editingId !== item.id">{{value}}</span>
                  <input v-if="key !== 'id' && key !== 'gender' && editingId === item.id" v-model="editData[key]" :value="value" :type="key === 'age' ? 'number' : 'text'" max="99">
                  <select v-if="key !== 'id' && key === 'gender' && editingId === item.id" v-model="editData[key]">
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                  </select>
                </td>
                <td class="action">
                  <span v-if="editingId == item.id" @click="cancelEdit()">
                    <button><i class="material-icons">cancel</i></button>
                  </span>
                  <span v-if="editingId == item.id" @click="updateUser(item.id)">
                    <button><i class="material-icons">save</i></button>
                  </span>
                  <span v-if="editingId !== item.id" @click="editUser(item)">
                    <button><i class="material-icons">create</i></button>
                  </span>
                  <span v-if="editingId !== item.id" @click="prepareDelete(item.id)">
                    <button><i class="material-icons">delete</i></button>
                  </span>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="empty" v-if="users.length == 0">
            <h3>
              No User Found
            </h3>
          </div>
        </div>
      </div>
      <form class="form-container" v-if="create" @submit.prevent="createUser()" class="create-user-form">
        <h1 class="title">Enroll</h1>
        <div class="form-layout">
          <input v-model="newUser.name" required type="text" placeholder="student name">
          <input v-model="newUser.school_name" required type="text" placeholder="School name">
          <div class="flexd-box">
            <select v-model="newUser.gender" required>
              <option value="M">Male</option>
              <option value="F">Female</option>
            </select>
            <input v-model="newUser.age" pattern="/[0-9]/g" max="99" required type="number" placeholder="age">
          </div>
          <div class="centered-button">
            <button type="submit">enroll</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- development version, includes helpful console warnings -->
  <script defer src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <!-- production version, optimized for size and speed 
    <script src="https://cdn.jsdelivr.net/npm/vue"></script> -->
  <script defer src="./js/main.js"></script>
</body>

</html>
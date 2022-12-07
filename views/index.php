<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>Alif Test</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>

<div class="container" id="booking">
    <div class="card mt-5">
        <div class="card-header">
            <div class="text-center">
                <h2>Form for booking rooms</h2>
                <h4 v-if="show_error" class="text-danger">{{ errors?.error ? errors.error : 'You can not book this room for this period!' }}</h4>
                <h4 v-if="message.length > 0" class="text-success">{{ message }}</h4>
            </div>
        </div>
        <div class="card-body">
            <form @submit.prevent="submit">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="full_name">Fullname</label>
                            <input type="text" name="full_name" class="form-control" v-model="full_name"
                                   placeholder="Fullname">
                            <span class="text-danger">{{ errors?.full_name }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" v-model="email"
                                   placeholder="Email">
                            <span class="text-danger">{{ errors?.email }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="from_date">From date</label>
                            <input type="datetime-local" class="form-control" id="from_date" v-model="from_date"
                                   name="from_date" :max="to_date" required>
                            <span class="text-danger">{{ errors?.from_date }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="to_date">To date</label>
                            <input type="datetime-local" class="form-control" id="to_date" v-model="to_date"
                                   name="to_date" :min="from_date" required>
                            <span class="text-danger">{{ errors?.to_date }}</span>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="room_id">Rooms</label>
                            <select name="room_id" id="room_id" class="form-control" v-model="room_id" required>
                                <option v-for="v in room_options" :value="v.id">{{ v.name }}</option>
                            </select>
                            <span class="text-danger">{{ errors?.room_id }}</span>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Book</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <template v-if="booked_rooms.length > 0">
        <div class="card mt-4">
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Fullname</th>
                        <th scope="col">Email</th>
                        <th scope="col">From Date</th>
                        <th scope="col">To Date</th>
                        <th scope="col">Emailed</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(br, index) in booked_rooms">
                        <th scope="row">{{ index + 1 }}</th>
                        <td>{{ br.full_name }}</td>
                        <td>{{ br.email }}</td>
                        <td>{{ br.from_date }}</td>
                        <td>{{ br.to_date }}</td>
                        <td v-if="br.emailed">Person was emailed</td>
                        <td v-else>
                            <button @click="emailPerson(br)" class="btn btn-info">Send email</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </template>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script>
    new Vue({
        el: "#booking",
        data: {
            host: window.location.host,
            full_name: null,
            email: null,
            room_id: null,
            from_date: null,
            to_date: null,
            show_error: false,
            message: '',
            room_options: [],
            errors: null,
            booking_options: [],
            booked_rooms: [],
        },
        mounted() {
            const vm = this

            fetch('/get-rooms')
                .then(response => response.json())
                .then(data => {
                    vm.room_options = data
                }).catch(err => console.log(err))
        },
        methods: {
            async submit(e) {
                e.preventDefault()
                const vm = this
                let resp = await fetch('/book-room', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        full_name: vm.full_name,
                        email: vm.email,
                        from_date: vm.from_date,
                        to_date: vm.to_date,
                        room_id: vm.room_id
                    })
                })
                let data = await resp.json()
                if (resp.ok) {
                    console.log(data)
                    vm.booked_rooms.push({
                        id: data.id,
                        full_name: data.full_name,
                        email: data.email,
                        from_date: data.from_date,
                        to_date: data.to_date,
                        emailed: Boolean(parseInt(data.emailed)),
                    })
                    vm.clean()
                } else {
                    vm.errors = data
                    vm.show_error = true
                }
            },
            async emailPerson(br) {
                const vm = this
                let resp = await fetch('/send-email', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: br.id,
                    })
                })
                let data = await resp.json()
                if (resp.ok) {
                    console.log(data)
                    br.emailed = true
                    vm.message = data.message

                    setTimeout(function () {
                        vm.message = ''
                    }, 3000)
                } else {
                    vm.errors = data
                    vm.show_error = true
                }
            },
            clean() {
                const vm = this
                vm.full_name = null
                vm.email = null
                vm.from_date = null
                vm.to_date = null
            },
            getBookedRooms(room_id, from_date, to_date) {
                if (!room_id || !from_date || !to_date) {
                    return
                }
                const vm = this
                let url = `/get-booked-room?room_id=${room_id}&from_date=${from_date}&to_date=${to_date}`

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        vm.show_error = data.length > 0
                        vm.booked_rooms = data
                    })
            }
        },
        watch: {
            'room_id'() {
                this.getBookedRooms(this.room_id, this.from_date, this.to_date)
            },
            'from_date'() {
                this.getBookedRooms(this.room_id, this.from_date, this.to_date)
            },
            'to_date'() {
                this.getBookedRooms(this.room_id, this.from_date, this.to_date)
            }
        }
    })
</script>
</body>
</html>
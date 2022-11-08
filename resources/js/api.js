import axios from "axios";

const local_storage_key = "access_token"
const api = axios.create();


api.interceptors.request.use(config => {
    if (localStorage.getItem(local_storage_key)) {
        config.headers.authorization = `Bearer ${localStorage.getItem(local_storage_key)}`
    }
    return config
}, error => {
    console.log("Request error");
})

api.interceptors.response.use((response) => {return response}, async (error) => {
    // console.log(error);
    const err = error.response
    // console.log(err);
    // console.log(err);
    // if (err.status === 401 && err.data.)
    // console.log(error.response);

    if (err.status === 401 && err.data.message === 'Unauthenticated.') {
        // console.log("Token expired or invalid")
        const old_token = localStorage.getItem(local_storage_key)
        if (!old_token) throw error
        if (old_token){
            const new_token = await api.refresh(old_token)
            error.config.headers.authorization =  `Bearer ${new_token}`
            // console.log('NEW TOKEN: ' + error.config.headers.authorization)
            return api.request(error.config)
        }

    } else throw error
        // const oldToken = localStorage.getItem(local_storage_key)
        // if (oldToken) {
            // return axios.post('/api/auth/refresh', {}, {
                // headers: {
                    // 'authorization': `Bearer ${oldToken}`
                // }
    //         }).then(res => {
    //             localStorage.setItem(local_storage_key, res.data.access_token)
    //             error.config.headers.authorization = `Bearer ${res.data.access_token}`
    //             return api.request(error.config)
    //         })
    //     }
    // } else throw error
})

// USERS API

api.userById = (id) => {
    return api.get(`/api/user/${id}`)
        .then(response => response.data.data)
        .catch(error => {throw error.response})
}

api.buyCar = (carID) => {
    return api.post('/api/user/buyCar', {
        car: carID
    })
        .then(response => response.data)
        .catch(error => {throw error.response})
}

api.sellCar = (personal_car_id) => {
    return api.post('/api/user/sellCar', {
        personal_car_id
    })
        .then(response => response.data)
        .catch(error => {throw error.response})
}

// CARS API

api.cars = () => {
    return api
        .get('/api/cars')
        .then(response => response.data.data)
        .catch(err => {throw err.response})
}

api.carById = (id) => {
    return api
        .get(`/api/cars/${id}`)
        .then(response => response.data.data)
        .catch(error => {throw error.response})
}


// AUTH API
api.refresh = (token) => {
    return axios
        .post('/api/auth/refresh', {}, {
            headers: {
                authorization: `Bearer ${token}`
            }
        })
        .then(response => {
            localStorage.setItem(local_storage_key, response.data.access_token)
            // console.log("Token has been updated  " + response.data.access_token);
            return response.data.access_token
        })
}

api.me = () => {
    return api.post('/api/auth/me')
        .then(response => response.data)
        .catch(error => {
            throw error.response
        })
        // .catch(err => throw err.response)
}

api.logout = () => {
    return api
        .post('/api/auth/logout')
        .then(response => {
            localStorage.removeItem('access_token')

        })
        .catch(error => {
            throw error.response
        })
}

api.register = (data) => {
    return api
        .post('/api/auth/register', data)
        .then(response => response.data)
        .catch(error => {throw error.response})
}


// ROULETTES

api.getRoulettes = () => {
    return api
        .get('/api/roulettes')
        .then(response => response.data.data)
        .catch(error => {throw error.response})
}

api.getRoulette = (id) => {
    return api
        .get(`/api/roulettes/${id}`)
        .then(response => response.data.data)
        .catch(error => {throw error.response})
}

api.openRoulette = (id) => {
    return api
        .post(`/api/roulettes/${id}/open`)
        .then(response => response.data)
        .catch(error => {throw error.response})
}

api.createRoulette = (data) => {
    return api
        .post(`/api/roulettes/create`, data)
        .then(response => response.data.data)
        .catch(error => {throw error.response})
}

export default api

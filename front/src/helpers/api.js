import axios from 'axios'

const api = axios.create({ baseURL: 'http://localhost/projects/new-vet/back/api' })

export async function get(endpoint, params = {}) {

  if (!endpoint) throw new Error('Please provide an endpoint for the API call')
  if (typeof endpoint !== 'string') throw new Error('Endpoint must be a string')
  if (typeof params !== 'object') throw new Error('Params must be an object')

  const response = await api.get(`/${endpoint}.php`, { params })

  return response.data
}

export async function post(endpoint, data = {}) {

  if (!endpoint) throw new Error('Please provide an endpoint for the API call')
  if (typeof endpoint !== 'string') throw new Error('Endpoint must be a string')
  if (typeof data !== 'object') throw new Error('Data must be an object')

  const response = await api.post(`/${endpoint}.php`, data)

  return response.data
}


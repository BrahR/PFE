import { FilePondType } from 'filepond'
import ziggyRoute from 'ziggy-js'
import Echo from 'laravel-echo'
import Pusher from 'pusher-js'
import { AxiosInstance } from 'axios'

declare global {
  type FilePond = FilePondType

  const route: typeof ziggyRoute
  interface Window {
    Echo: Echo
    _: typeof import('lodash')
    axios: AxiosInstance
    Pusher: typeof Pusher
  }

  const Echo: Echo
  const _: typeof import('lodash')
  const Ziggy: typeof import('ziggy-js')
  const axios: AxiosInstance
}
//
// declare module 'ziggy-js' {
//   interface Ziggy {
//     namedRoutes: Record<string, string>
//     baseUrl: string
//     baseProtocol: string
//     baseDomain: string
//     basePort: number | null
//     defaultParameters: Record<string, string>
//   }
// }

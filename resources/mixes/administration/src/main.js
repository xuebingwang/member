import {headerMixin, installMixin, routerMixin} from './helpers/mixes'

let Core = {}

headerMixin(Core)
installMixin(Core)
routerMixin(Core)

export default Core
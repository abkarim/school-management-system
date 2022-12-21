const productionURL = '';
const devURL = 'http://localhost';
const url = process.env.NODE_ENV === 'production' ? productionURL : devURL;

const data = {
    image: `${url}/public/uploads/image`
}

export default data;
import { Routes, Route, BrowserRouter} from 'react-router-dom';

import Productos from './components/Productos';


function App() {

  return (

    <BrowserRouter>

      <Routes>

     

        <Route path='/' element={<Productos/>}></Route>

   

      </Routes>

    </BrowserRouter>

  )

}


export default App;
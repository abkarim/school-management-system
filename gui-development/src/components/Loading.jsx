import load from '../img/load.png';
export default function Loading() {
    return (
        <div className="absolute inset-0 bg-black bg-opacity-80 backdrop-blur-sm flex">
            <img src={load} alt="loading" className='m-auto animate-spin h-10 lg:h-16' />
        </div>
    )
}
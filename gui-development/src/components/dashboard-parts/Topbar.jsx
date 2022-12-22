import { useState } from 'react';
import url from '../../util/URL';

function Menu() {
    return (
        <div className='absolute right-4 shadow-2xl rounded-sm bg-white p-2'>
            menu
        </div>
    )
}

export default function Topbar({ ...props }) {
    const [isMenuOpen, setIsMenuOpen] = useState(false);
    return (
        <header className='relative'>
            <div className="h-full bg-white shadow-xl p-2 flex justify-between items-center">
                <h4 className="font-lato text-lg">Title here</h4>
                <div>
                    <span className="inline-block h-12 bg-white-500 border-2 border-emerald-300 rounded-full p-1 cursor-pointer" onClick={() => setIsMenuOpen(!isMenuOpen)}>
                        <img src={`${url.image}/user.png`} alt="user" className="max-h-full" />
                    </span>
                </div>
            </div>
            {isMenuOpen && <Menu />}
        </header>
    )
}
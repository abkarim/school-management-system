import { Link } from "react-router-dom";
import {useState} from "react";

function MenuItem({ to, children, ...props }) {
  return (
    <Link className="inline-block" to={to} {...props}>
      {children}
    </Link>
  );
}

export default function Sidebar({ ...props }) {
  const [isMenuOpen, setIsMenuOpen] = useState(true);
  return (
    <aside className={`bg-white relative shadow-xl min-h-screen w-full ${isMenuOpen ? 'max-w-fit' : 'max-w-0' }`} >
      <div className="overflow-hidden transition">
          <MenuItem>School</MenuItem>
      </div>
      <span className="inline-block absolute bg-emerald-300 rounded-full text-white font-extrabold font-lato px-2 cursor-pointer select-none" onClick={() => setIsMenuOpen(!isMenuOpen)} > {isMenuOpen? '<' : '>'} </span>
    </aside>
  );
}

import { useState } from "react";
import url from "../../util/URL";
import { Link } from "react-router-dom";

function MenuLink({ to, children, ...props }) {
  return (
    <Link
      className="inline-block w-full px-2 cursor-pointer hover:bg-gray-100 font-sans"
      {...props}
      to={to}>
      {children}
    </Link>
  );
}

function Menu() {
  return (
    <div className="absolute right-4 shadow-2xl rounded-sm bg-white">
      <MenuLink to="/profile">Profile</MenuLink>
      <MenuLink to="/settings">Settings</MenuLink>
      <hr />
      <MenuLink to="/logout">Logout</MenuLink>
    </div>
  );
}

export default function Topbar({ ...props }) {
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  return (
    <header className="relative z-0" {...props}>
      <div className="h-full bg-white shadow-xl p-2 flex justify-between items-center">
        <h4 className="font-lato text-lg font-semibold">Title here</h4>
        <div>
          <span
            className="inline-block h-10 bg-white-500 border-2 border-emerald-300 rounded-full p-1 cursor-pointer"
            onClick={() => setIsMenuOpen(!isMenuOpen)}>
            <img
              src={`${url.image}/user.png`}
              alt="user"
              className="max-h-full"
            />
          </span>
        </div>
      </div>
      {isMenuOpen && <Menu />}
    </header>
  );
}

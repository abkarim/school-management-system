import { Link } from "react-router-dom";
import { useState } from "react";

function MenuItem({ to, children, ...props }) {
  return (
    <Link
      className="inline-block font-sans font-semibold hover:bg-gray-100 px-4 text-left border-b-2 border-black"
      to={to}
      {...props}>
      {children}
    </Link>
  );
}

export default function Sidebar({ ...props }) {
  const [isMenuOpen, setIsMenuOpen] = useState(true);
  return (
    <aside
      className={`relative shadow-xl min-h-screen w-full transition bg-white ${
        isMenuOpen ? "max-w-fit" : "max-w-0"
      }`}>
      <div className="overflow-hidden transition flex flex-col">
        <MenuItem to="/school">School</MenuItem>
        <MenuItem to="#">Users</MenuItem>
        {/* Users list on drop down */}
        <div className="flex flex-col ml-2">
          <MenuItem to="/users/admin">Admin</MenuItem>
          <MenuItem to="/users/accountant">Accountant</MenuItem>
          <MenuItem to="/users/student">Student</MenuItem>
          <MenuItem to="/users/librarian">Librarian</MenuItem>
          <MenuItem to="/users/parent">Parent</MenuItem>
          <MenuItem to="/users/teacher">Teacher</MenuItem>
        </div>
        <MenuItem to="/class">Class</MenuItem>
        <MenuItem to="/notice">Notice</MenuItem>
        <MenuItem to="/exam">Exam</MenuItem>
        <MenuItem to="/book">Books</MenuItem>
      </div>
      <span
        title={isMenuOpen ? "close menu" : "open menu"}
        className={`inline-block absolute bg-emerald-300 rounded-full text-white font-extrabold font-lato px-2 cursor-pointer select-none transition top-52 ${
          isMenuOpen ? "-right-5" : "-left-2 hover:left-1"
        }`}
        onClick={() => setIsMenuOpen(!isMenuOpen)}>
        {isMenuOpen ? "<" : ">"}
      </span>
    </aside>
  );
}
